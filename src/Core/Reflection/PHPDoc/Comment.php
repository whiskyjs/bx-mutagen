<?php

declare(strict_types=1);

namespace WJS\Mutagen\Core\Reflection\PHPDoc;

/**
 * @package WJS\Mutagen\Core\Reflection\PHPDoc
 */
final class Comment
{
    /**
     * @var string
     */
    private string $comment;

    /**
     * @param string $comment
     */
    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return array
     */
    public function getAnnotations(): array
    {
        $lines = array_map(function ($line) {
            return trim($line, " *");
        }, explode("\n", $this->comment));

        $lines = array_filter($lines, function ($line) {
            return strpos($line, "@") === 0;
        });

        $annotations = [];

        foreach ($lines as $line) {
            [$param, $value] = explode(" ", $line, 2);
            $annotations[trim($param)][] = $value;
        }

        return $annotations;
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function getAnnotation(string $name): ?array
    {
        return $this->getAnnotations()[$name] ?? null;
    }
}
