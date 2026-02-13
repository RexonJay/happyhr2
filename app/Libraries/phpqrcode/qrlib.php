<?php
// Legacy phpqrcode compatibility shim.
// Provides a global QRcode::png(...) method similar to the old phpqrcode qrlib.
// Internally uses endroid/qr-code if available.

use Endroid\QrCode\Builder\Builder;

if (!class_exists('QRcode')) {
    class QRcode
    {
        /**
         * Generate a QR PNG.
         * Signature kept similar to legacy phpqrcode: png($text, $outfile = false, $level = 'L', $size = 3, $margin = 4, $saveandprint = false)
         * - $text: content
         * - $outfile: path to save file, or false to output directly
         * - $level: error correction level (ignored, kept for compatibility)
         * - $size: module size (we map it to pixel dimensions)
         * - $margin: margin around QR
         * - $saveandprint: if true save to $outfile and also output
         */
        public static function png($text, $outfile = false, $level = 'L', $size = 3, $margin = 4, $saveandprint = false)
        {
            // Map legacy "size" to pixel size. Tune if needed.
            $pixelSize = (int) max(100, $size * 100);

            // Build QR code using endroid if available
            if (class_exists(Builder::class)) {
                try {
                    $result = Builder::create()
                        ->data($text)
                        ->size($pixelSize)
                        ->margin((int) $margin)
                        ->build();

                    $png = $result->getString();
                } catch (Throwable $e) {
                    // Fallback: produce a 1x1 transparent PNG to avoid fatal errors
                    $png = self::emptyPng();
                }
            } else {
                // No endroid available; fallback to empty PNG
                $png = self::emptyPng();
            }

            if ($outfile) {
                // Ensure directory exists
                $dir = dirname($outfile);
                if (!is_dir($dir)) {
                    @mkdir($dir, 0755, true);
                }

                @file_put_contents($outfile, $png);
            }

            if ($outfile && !$saveandprint) {
                // Only saved, not printed
                return true;
            }

            // Output PNG to browser (legacy behaviour)
            if (!headers_sent()) {
                header('Content-Type: image/png');
            }
            echo $png;
            return true;
        }

        private static function emptyPng()
        {
            // Minimal 1x1 transparent PNG
            return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=');
        }
    }
}
