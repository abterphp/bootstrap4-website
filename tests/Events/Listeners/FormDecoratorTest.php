<?php

declare(strict_types=1);

namespace AbterPhp\Bootstrap4Website\Events\Listeners;

use AbterPhp\Framework\Events\FormReady;
use AbterPhp\Framework\Form\IForm;
use AbterPhp\Website\Events\WebsiteReady;
use Opulence\Views\IView;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use AbterPhp\Bootstrap4Website\Decorator\Form;

class FormDecoratorTest extends TestCase
{
    /** @var FormDecorator - System Under Test */
    protected $sut;

    /** @var MockObject|Form */
    protected $formDecoratorMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->formDecoratorMock = $this->createMock(Form::class);
        $this->formDecoratorMock->expects($this->any())->method('init')->willReturnSelf();

        $this->sut = new FormDecorator($this->formDecoratorMock);
    }

    public function testHandle()
    {
        $nodes = ['foo', 'bar'];

        $formStub = $this->createMock(IForm::class);
        $formStub
            ->expects($this->any())
            ->method('getExtendedDescendantNodes')
            ->willReturn($nodes);

        $event = new FormReady($formStub);

        $this->formDecoratorMock
            ->expects($this->once())
            ->method('decorate')
            ->with([$formStub, 'foo', 'bar']);

        $this->sut->handle($event);
    }
}
