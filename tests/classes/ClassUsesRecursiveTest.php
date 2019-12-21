<?php

/**
 * Polyfiller
 *
 * LICENSE
 *
 * This is free and unencumbered software released into the public domain.
 *
 * Anyone is free to copy, modify, publish, use, compile, sell, or distribute this software, either in source code form or
 * as a compiled binary, for any purpose, commercial or non-commercial, and by any means.
 *
 * In jurisdictions that recognize copyright laws, the author or authors of this software dedicate any and all copyright
 * interest in the software to the public domain. We make this dedication for the benefit of the public at large and to the
 * detriment of our heirs and successors. We intend this dedication to be an overt act of relinquishment in perpetuity of
 * all present and future rights to this software under copyright law.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT
 * OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * For more information, please refer to <https://unlicense.org>
 *
 */

namespace RQuadlingTests\classes;

use PHPUnit\Framework\TestCase;
use RQuadlingTests\classes\Fixtures\FemaleTrait;
use RQuadlingTests\classes\Fixtures\GrandParentClass;
use RQuadlingTests\classes\Fixtures\GrandParentTrait;
use RQuadlingTests\classes\Fixtures\MaleTrait;
use RQuadlingTests\classes\Fixtures\ParentClass;
use RQuadlingTests\classes\Fixtures\ParentTrait;

class ClassUsesRecursiveTest extends TestCase
{
    /**
     * @param string|object $class
     *
     * @dataProvider providerForClassUsesRecursive
     */
    public function testClassUsesRecursive($class, array $expected)
    {
        $this->assertEquals($expected, class_uses_recursive($class));
    }

    public function providerForClassUsesRecursive()
    {
        return
            [
                'GrandParent' => [
                    GrandParentClass::class,
                    [
                        GrandParentTrait::class => GrandParentTrait::class,
                        ParentTrait::class => ParentTrait::class,
                        MaleTrait::class => MaleTrait::class,
                        FemaleTrait::class => FemaleTrait::class,
                    ],
                ],
                'Parent' => [
                    ParentClass::class,
                    [
                        ParentTrait::class => ParentTrait::class,
                        MaleTrait::class => MaleTrait::class,
                        FemaleTrait::class => FemaleTrait::class,
                    ],
                ],
                'GrandParentInstance' => [
                    new GrandParentClass(),
                    [
                        GrandParentTrait::class => GrandParentTrait::class,
                        ParentTrait::class => ParentTrait::class,
                        MaleTrait::class => MaleTrait::class,
                        FemaleTrait::class => FemaleTrait::class,
                    ],
                ],
                'ParentInstance' => [
                    new ParentClass(),
                    [
                        ParentTrait::class => ParentTrait::class,
                        MaleTrait::class => MaleTrait::class,
                        FemaleTrait::class => FemaleTrait::class,
                    ],
                ],
            ];
    }
}
