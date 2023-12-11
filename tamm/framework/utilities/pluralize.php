<?php

namespace Tamm\Framework\Utilities;

class Pluralizer
{
    public static function pluralize($noun)
    {
        $irregularPlurals = array(
            'man' => 'men',
            'woman' => 'women',
            'child' => 'children',
            'tooth' => 'teeth',
            'foot' => 'feet',
            'mouse' => 'mice',
            'goose' => 'geese',
            'louse' => 'lice',
            'ox' => 'oxen',
            'die' => 'dice',
            'phenomenon' => 'phenomena',
            'criterion' => 'criteria',
            'analysis' => 'analyses',
            'bacterium' => 'bacteria',
            'medium' => 'media',
            'syllabus' => 'syllabuses',
            'datum' => 'data',
            'appendix' => 'appendices',
            'index' => 'indexes',
            'radius' => 'radiuses',
            // Add more irregular plural forms as needed
        );

        $uncountableNouns = array(
            'sheep',
            'fish',
            'deer',
            'species',
            // Add more uncountable nouns as needed
        );

        // Check for irregular plurals
        if (array_key_exists($noun, $irregularPlurals)) {
            return $irregularPlurals[$noun];
        }

        // Check for uncountable nouns
        if (in_array($noun, $uncountableNouns)) {
            return $noun;
        }

        // Apply common pluralization rules
        $rules = array(
            '/(s)tatus$/i' => '\1tatuses',
            '/(quiz)$/i' => '\1zes',
            '/^(ox)$/i' => '\1en',
            '/([m|l])ouse$/i' => '\1ice',
            '/(matr|vert|ind)(?:ix|ex)$/i' => '\1ices',
            '/(x|ch|ss|sh)$/i' => '\1es',
            '/([^aeiouy]|qu)y$/i' => '\1ies',
            '/(hive)$/i' => '\1s',
            '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
            '/(shea|lea|loa|thie)f$/i' => '\1ves',
            '/sis$/i' => 'ses',
            '/([ti])um$/i' => '\1a',
            '/(tomat|potat|ech|her|vet)o$/i' => '\1oes',
            '/(bu)s$/i' => '\1ses',
            '/(alias)$/i' => '\1es',
            '/(octop)us$/i' => '\1i',
            '/(ax|test)is$/i' => '\1es',
            '/(us)$/i' => '\1es',
            '/s$/i' => 's',
            '/$/' => 's'
        );

        foreach ($rules as $rule => $replacement) {
            if (preg_match($rule, $noun)) {
                return preg_replace($rule, $replacement, $noun);
            }
        }

        return $noun . 's'; // Default to adding "s" for plural
    }
}

// // Example usage
// $word = 'cat';
// $plural = Pluralizer::pluralize($word);
// echo "Singular: $word, Plural: $plural";