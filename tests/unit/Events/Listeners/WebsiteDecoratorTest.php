<?php

declare(strict_types=1);

namespace AbterPhp\Bootstrap4Website\Events\Listeners;

use AbterPhp\Website\Events\WebsiteReady;
use Opulence\Views\IView;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class WebsiteDecoratorTest extends TestCase
{
    /** @var WebsiteDecorator System Under Test */
    protected $sut;

    const HEADER = 'foo';
    const FOOTER = 'bar';

    public function setUp()
    {
        parent::setUp();

        $this->sut = new WebsiteDecorator(static::HEADER, static::FOOTER);
    }

    public function testHandleWithoutSetVars()
    {
        $viewMock = $this->getMockBuilder(IView::class)
            ->setMethods(
                [
                    'getContents',
                    'getDelimiters',
                    'getPath',
                    'getVar',
                    'getVars',
                    'hasVar',
                    'setContents',
                    'setDelimiters',
                    'setPath',
                    'setVar',
                    'setVars',
                ]
            )
            ->getMock();

        $viewMock->expects($this->at(0))->method('hasVar')->willReturn(false);
        $viewMock->expects($this->at(1))->method('hasVar')->willReturn(false);

        $viewMock->expects($this->at(2))->method('setVar')->with('preHeader', static::HEADER);
        $viewMock->expects($this->at(3))->method('setVar')->with('preFooter', static::FOOTER);

        /** @var WebsiteReady|MockObject $stubWebsiteReady */
        $stubWebsiteReady = $this->getMockBuilder(WebsiteReady::class)
            ->disableOriginalConstructor()
            ->setMethods(['getView'])
            ->getMock();

        $stubWebsiteReady->expects($this->any())->method('getView')->willReturn($viewMock);

        $this->sut->handle($stubWebsiteReady);
    }

    public function testHandleWithSetVars()
    {
        $setHeader = 'quix';
        $setFooter = 'baz';

        $viewMock = $this->getMockBuilder(IView::class)
            ->setMethods(
                [
                    'getContents',
                    'getDelimiters',
                    'getPath',
                    'getVar',
                    'getVars',
                    'hasVar',
                    'setContents',
                    'setDelimiters',
                    'setPath',
                    'setVar',
                    'setVars',
                ]
            )
            ->getMock();

        $viewMock->expects($this->at(0))->method('hasVar')->willReturn(true);
        $viewMock->expects($this->at(1))->method('getVar')->with('preHeader')->willReturn($setHeader);

        $viewMock->expects($this->at(2))->method('hasVar')->willReturn(true);
        $viewMock->expects($this->at(3))->method('getVar')->with('preFooter')->willReturn($setFooter);

        $viewMock->expects($this->at(4))->method('setVar')->with('preHeader', static::HEADER . $setHeader);
        $viewMock->expects($this->at(5))->method('setVar')->with('preFooter', static::FOOTER . $setFooter);

        /** @var WebsiteReady|MockObject $stubWebsiteReady */
        $stubWebsiteReady = $this->getMockBuilder(WebsiteReady::class)
            ->disableOriginalConstructor()
            ->setMethods(['getView'])
            ->getMock();

        $stubWebsiteReady->expects($this->any())->method('getView')->willReturn($viewMock);

        $this->sut->handle($stubWebsiteReady);
    }
}
