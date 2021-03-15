<?php

namespace TKusy\SimpleAssert;

use Psr\Log\LoggerInterface;

class Assert
{
    public const WARNING = 300;
    public const CRITICAL = 500;

    /** @var LoggerInterface|null */
    private static $logger;

    /** @var int  */
    private static $defaultLogLevel = self::WARNING; // warning

    public static function init(LoggerInterface $logger, int $defaultLogLevel = self::WARNING): void
    {
        self::$logger = $logger;
        self::$defaultLogLevel = $defaultLogLevel;
    }

    public static function assert(
        bool $condition,
        ?string $failMessage = 'Assertion failed',
        ?int $logLevel = self::WARNING,
        ?array $context = []
    ): void {
        if (!$condition) {
            if (self::$logger) {
                self::$logger->log($logLevel ?? self::$defaultLogLevel, $failMessage, $context);
            }
            throw new AssertException($failMessage);
        }
    }
}
