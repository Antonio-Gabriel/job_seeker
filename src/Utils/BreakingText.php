<?php

function breakingText(string $text, int $limit)
{
    $fullText = strip_tags($text);

    if (strlen($fullText) > $limit) {

        /// Truncate string
        $fullTextSplit = substr($fullText, 0, $limit);

        $textBreaking = substr_replace(
            $fullTextSplit, "...", $limit
        );

        return $textBreaking;
    }
}
