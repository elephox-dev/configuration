<?php
declare(strict_types=1);

namespace Elephox\Configuration;

use Elephox\Configuration\Memory\MemoryConfigurationSource;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Elephox\Configuration\ConfigurationSection
 * @covers \Elephox\Configuration\ConfigurationBuilder
 * @covers \Elephox\Configuration\ConfigurationRoot
 * @covers \Elephox\OOR\Str
 * @covers \Elephox\OOR\Arr
 * @covers \Elephox\OOR\Filter
 * @covers \Elephox\Collection\Enumerable
 * @covers \Elephox\Collection\Iterator\FlipIterator
 * @covers \Elephox\Collection\Iterator\ReverseIterator
 * @covers \Elephox\Collection\Iterator\SplObjectStorageIterator
 * @covers \Elephox\Collection\ObjectSet
 * @covers \Elephox\Configuration\ConfigurationPath
 * @covers \Elephox\Configuration\Memory\MemoryConfigurationProvider
 * @covers \Elephox\Configuration\Memory\MemoryConfigurationSource
 * @covers \Elephox\Collection\IteratorProvider
 *
 * @uses \Elephox\Configuration\HasArrayData
 *
 * @internal
 */
class ConfigurationSectionTest extends TestCase
{
	public function testGetSection(): void
	{
		$configBuilder = new ConfigurationBuilder();
		$configBuilder->add(new MemoryConfigurationSource(['this is' => 'a test', 'nested' => ['a' => 'b', 'c' => ['foo' => 'bar']]]));
		$root = $configBuilder->build();

		$config = new ConfigurationSection($root, 'nested');
		$section = $config->getSection('c');
		static::assertInstanceOf(ConfigurationSection::class, $section);
		static::assertEquals('bar', $section->getSection('foo')->getValue());
	}

	public function testInvalidOffsetUnset(): void
	{
		$configBuilder = new ConfigurationBuilder();
		$configBuilder->add(new MemoryConfigurationSource(['this is' => 'a test', 'nested' => ['a' => 'b', 'c' => ['foo' => 'bar']]]));
		$root = $configBuilder->build();

		$config = new ConfigurationSection($root, 'nested');

		$this->expectException(InvalidArgumentException::class);
		$config->offsetUnset(123);
	}

	public function testInvalidOffsetSet(): void
	{
		$configBuilder = new ConfigurationBuilder();
		$configBuilder->add(new MemoryConfigurationSource(['this is' => 'a test', 'nested' => ['a' => 'b', 'c' => ['foo' => 'bar']]]));
		$root = $configBuilder->build();

		$config = new ConfigurationSection($root, 'nested');

		$this->expectException(InvalidArgumentException::class);
		$config->offsetSet(123, 'test');
	}

	public function testInvalidOffsetExists(): void
	{
		$configBuilder = new ConfigurationBuilder();
		$configBuilder->add(new MemoryConfigurationSource(['this is' => 'a test', 'nested' => ['a' => 'b', 'c' => ['foo' => 'bar']]]));
		$root = $configBuilder->build();

		$config = new ConfigurationSection($root, 'nested');

		$this->expectException(InvalidArgumentException::class);
		$config->offsetExists(123);
	}

	public function testInvalidOffsetGet(): void
	{
		$configBuilder = new ConfigurationBuilder();
		$configBuilder->add(new MemoryConfigurationSource(['this is' => 'a test', 'nested' => ['a' => 'b', 'c' => ['foo' => 'bar']]]));
		$root = $configBuilder->build();

		$config = new ConfigurationSection($root, 'nested');

		$this->expectException(InvalidArgumentException::class);
		$config->offsetGet(123);
	}
}
