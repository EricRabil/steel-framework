<?php

namespace Steel\Localization;

interface ILocalizer{
    public function translate_string($str, $locale);
    public function get_available_locale();
    public function set_locale($locale);
    public function get_all_translated_strings($locale);
    public function dump_locale();
    public function load_locale(...$locale);
}