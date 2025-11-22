<?php

namespace App\Services;

class BlockRenderer
{
    public static function render(array $block, array $data = []): string
    {
        // Convert attributes array → HTML string
        $attrToHtml = function ($attrs) {
            $html = '';
            foreach ($attrs as $key => $value) {
                if (is_array($value)) {
                    $html .= " {$key}=\"" . implode(' ', $value) . "\"";
                } else {
                    $html .= " {$key}=\"{$value}\"";
                }
            }
            return $html;
        };

        $tag = $block['tag'] ?? 'div';
        $attrs = $attrToHtml($block['attrs'] ?? []);

        // Replace placeholders
        $inner = $block['innerText'] ?? '';
        foreach ($data as $key => $value) {
            $inner = str_replace("{!-$key-!}", $value, $inner);
        }

        // Start HTML
        $html = "<{$tag}{$attrs}>";

        // Render children if exists
        if (!empty($block['children'])) {
            foreach ($block['children'] as $child) {
                $html .= self::render($child, $data);
            }
        } else {
            $html .= $inner;
        }

        $html .= "</{$tag}>";

        return $html;
    }
}
