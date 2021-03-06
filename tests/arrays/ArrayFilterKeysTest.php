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

namespace RQuadlingTests\arrays;

use PHPUnit\Framework\TestCase;

class ArrayFilterKeysTest extends TestCase
{
    /**
     * @dataProvider providerForArrayFilterKeys
     *
     * @param array<int, array<int|string, true>> $data
     * @param (\Closure(string):int) $callback
     * @param array<string, true> $expected
     */
    public function testArrayFilterKeys(array $data, ?callable $callback, array $expected): void
    {
        $this->assertEquals($expected, array_filter_keys($data, $callback));
    }

    /**
     * @return array<string, array<int, array<int|string, true>|(Closure(string):int)|string|null>>
     */
    public function providerForArrayFilterKeys()
    {
        return
            [
                'Empty set with no filter' => [[], null, []],
                'Empty set with function filter' => [[], 'strlen', []],
                'Empty set with callable filter' => [
                    [],
                    function (string $key): int {
                        return \strlen($key);
                    },
                    [],
                ],
                'Falsy keys filtered with no callback' => [[true, '' => true, '0' => true], null, []],
                'Function filter' => [[true, '' => true, '0' => true], 'strlen', ['0' => true]],
                'Callable filter' => [
                    [true, '' => true, '0' => true],
                    function (string $key): int {
                        return \strlen($key);
                    },
                    ['0' => true],
                ],
            ];
    }
}
