<?php

namespace Steel\Localization;

interface ILocale{
    public function get_qualified_name();
    public function get_sub_locale();
    public function get_json_path();
    public function get_json_name();
    public function set_qualified_name($fqln);
    public function add_sub_locale(...$locale);
    public function reset_sub_locale();
    public function set_json_name($name);
    public function set_json_path($path);
}