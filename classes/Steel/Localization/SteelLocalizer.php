<?php

namespace Steel\Localization;

/*
 * Baked-in localizer, good starting point but should not be used as your production driver. Always optimize your localizer for your application.
 */
class SteelLocalizer implements ILocalizer{
    
    private $primary_locale;
    
    private $locale = [];
    
    private $strings = [];
    
    /*
     * Empties locale.
     */
    public function dump_locale() {
        $this->locale = [];
    }

    public function get_all_translated_strings($locale) {
        return $this->strings;
    }

    public function get_available_locale() {
        return $this->locale;
    }

    public function set_locale(\Steel\Localization\ILocale $locale) {
        if(!$this->is_loaded($locale)){
            $this->load_locale($locale);
        }
        $this->primary_locale = $locale;
    }

    public function translate_string($str, \Steel\Localization\ILocale $locale) {
        if(!$this->is_loaded($locale)){
            return false;
        }
        if(!array_key_exists($locale->get_qualified_name(), $this->strings)){
            return $str;
        }
        if(!in_array($str, $this->strings[$locale->get_qualified_name()])){
            return $str;
        }
        return $this->strings[$locale->get_qualified_name()][$str];
    }
    
    private function is_loaded(\Steel\Localization\ILocale $locale){
        return in_array($locale->get_qualified_name(), $this->locale);
    }

    public function load_locale(\Steel\Localization\ILocale ...$locale) {
        foreach($locale as $toLoad){
            if($this->is_loaded($toLoad)){
                return;
            }
            $translated = json_decode(file_get_contents($toLoad->get_json_path()), true);
            $this->strings[$toLoad->get_qualified_name()] = $translated;
            $this->locale[] = $toLoad->get_qualified_name();
        }
    }

}