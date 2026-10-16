<?php

/**
 * Responsive image helper.
 *
 * Emits an <img> tag with srcset/sizes built from naming-convention variants:
 *   assets/images/photo.webp
 *   assets/images/photo-400.webp
 *   assets/images/photo-800.webp
 *   assets/images/photo-1200.webp
 *   assets/images/photo-1600.webp
 *   assets/images/photo-1920.webp
 *
 * Variants are only included if the file exists on disk, so the helper is
 * safe to deploy before/without the variant files (it silently degrades to
 * the original single-src behavior — no broken URLs, layout unchanged).
 */

if (! function_exists('responsive_img')) {

    /**
     * @param string $src   Filename ("hero.webp") or asset path ("assets/images/hero.webp")
     * @param string $alt   Alt text (required, even if empty string for decorative)
     * @param array  $opts  width, height, sizes, loading ('eager'|'lazy'), fetchpriority,
     *                      class, style, id
     *
     * @return string A fully-formed <img ...> element.
     */
    function responsive_img(string $src, string $alt = '', array $opts = []): string
    {
        $width   = isset($opts['width'])         ? (int) $opts['width']     : null;
        $height  = isset($opts['height'])        ? (int) $opts['height']    : null;
        $sizes   = isset($opts['sizes'])         ? (string) $opts['sizes']  : '100vw';
        $loading = isset($opts['loading'])       ? (string) $opts['loading']: 'lazy';
        $fp      = isset($opts['fetchpriority']) ? (string) $opts['fetchpriority'] : null;
        $class   = isset($opts['class'])         ? (string) $opts['class']  : null;
        $style   = isset($opts['style'])         ? (string) $opts['style']  : null;
        $id      = isset($opts['id'])            ? (string) $opts['id']     : null;

        // Normalize: bare filename -> assets/images/<file>
        if (! str_contains($src, '/')) {
            $src = 'assets/images/' . $src;
        }
        $src = ltrim($src, '/');

        $pathInfo = pathinfo($src);
        $dir      = $pathInfo['dirname']  ?? '';
        $base     = $pathInfo['filename'] ?? '';
        $ext      = $pathInfo['extension'] ?? 'webp';

        $srcsetParts = [];   // For the <img srcset> (native format, same $ext)
        $avifParts   = [];   // For the optional <source type="image/avif"> srcset
        $widthsToTry = [400, 800, 1200, 1600, 1920];
        $maxAllowed  = $width ? (int) $width : 1920;

        foreach ($widthsToTry as $w) {
            if ($w >= $maxAllowed) {
                continue;
            }
            $variantRel = "{$dir}/{$base}-{$w}.{$ext}";
            $variantAbs = FCPATH . $variantRel;
            if (is_file($variantAbs)) {
                $srcsetParts[] = base_url($variantRel) . ' ' . $w . 'w';
            }
            // AVIF sibling — same naming pattern with .avif extension
            $avifRel = "{$dir}/{$base}-{$w}.avif";
            if (is_file(FCPATH . $avifRel)) {
                $avifParts[] = base_url($avifRel) . ' ' . $w . 'w';
            }
        }

        // Include original at its native width (when known) so browser can pick
        // it on large screens. When width isn't known, the original is still
        // available via the src attribute as a fallback.
        if ($width) {
            $srcsetParts[] = base_url($src) . ' ' . (int) $width . 'w';
            $avifBaseRel = "{$dir}/{$base}.avif";
            if (is_file(FCPATH . $avifBaseRel)) {
                $avifParts[] = base_url($avifBaseRel) . ' ' . (int) $width . 'w';
            }
        }

        $attrs   = [];
        $attrs[] = 'src="' . esc(base_url($src)) . '"';

        // Emit srcset whenever we have at least one variant file on disk.
        if (count($srcsetParts) >= 1) {
            $attrs[] = 'srcset="' . esc(implode(', ', $srcsetParts)) . '"';
            $attrs[] = 'sizes="'  . esc($sizes) . '"';
        }

        $attrs[] = 'alt="' . esc($alt) . '"';

        if ($width !== null)  { $attrs[] = 'width="'  . $width  . '"'; }
        if ($height !== null) { $attrs[] = 'height="' . $height . '"'; }
        if ($loading !== '')  { $attrs[] = 'loading="' . esc($loading) . '"'; }
        if ($fp !== null)     { $attrs[] = 'fetchpriority="' . esc($fp) . '"'; }
        // Async decoding for lazy images so decode happens off-main-thread.
        // Skipped on eager/high-priority images (LCP) to avoid delaying paint.
        if ($loading !== 'eager' && $fp !== 'high') {
            $attrs[] = 'decoding="async"';
        }
        if ($class !== null)  { $attrs[] = 'class="' . esc($class) . '"'; }
        if ($style !== null)  { $attrs[] = 'style="' . esc($style, 'attr') . '"'; }
        if ($id !== null)     { $attrs[] = 'id="'    . esc($id) . '"'; }

        $imgTag = '<img ' . implode(' ', $attrs) . '>';

        // If any AVIF siblings exist on disk, wrap in <picture> so AVIF-capable
        // browsers pick the smaller format. Without any AVIF, return plain <img>
        // (backward compatible — no markup change for images that don't have AVIF).
        if (count($avifParts) >= 1) {
            $avifSrcset = esc(implode(', ', $avifParts));
            $avifSizes  = esc($sizes);
            return '<picture>'
                . '<source type="image/avif" srcset="' . $avifSrcset . '" sizes="' . $avifSizes . '">'
                . $imgTag
                . '</picture>';
        }

        return $imgTag;
    }
}
