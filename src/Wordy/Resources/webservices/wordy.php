<?php
// PHP-based Guzzle Service Description for the Wordy API
return array(
    'name'          => 'Wordy API',
    'apiVersion'    => 'v1',
    'description'   => 'An example API to play with Guzzle Service Descriptions',
    'operations'    => array(
        'GetWords'  => array(
            'httpMethod'    => 'GET',
            'uri'           => '/words/',
            'summary'       => 'Returns the entire collection of words.',
            'responseClass' => 'GetWordsOutput',
            'parameters'    => array(
                'page' => array(
                    'location' => 'query',
                    'type' => 'integer'
                ),
                'limit' => array(
                    'location' => 'query',
                    'type' => 'integer'
                )
            ),
        ),
        'FindWord'  => array(
            'httpMethod'    => 'GET',
            'uri'           => '/search/array(word)',
            'summary'       => 'Attempts to find a word in the collection.',
            'responseClass' => 'GetWordOutput',
            'parameters'    => array(
                'position'  => array(
                    'location'  => 'query',
                    'sentAs'    => 'pos',
                    'type'      => 'string',
                    'required'  => true
                )
            )
        ),
        'GetWord' => array(
            'httpMethod' => 'GET',
            'uri' => '/words/array(pos)',
            'summary' => 'Retrieves the word from the collection at position {pos}.',
            'responseClass' => 'GetWordOutput',
            'parameters' => array(
            'position' => array(
                'location' => 'query',
                    'sentAs' => 'pos',
                    'type' => 'string',
                    'required' => true
                )
            )
        ),
        'AddWord' => array(
            'httpMethod' => 'POST',
            'uri' => '/words/',
            'summary' => 'Adds a word to the collection.',
            'responseClass' => 'AddWordOutput',
            'parameters' => array(
                'word' => array(
                    'location' => 'postField',
                    'type' => 'string',
                    'required' => true
                )
            ),
            'additionalParameters' => array(
                'location' => 'postField'
            )
        ),
        'RemoveWord' => array(
            'httpMethod' => 'DELETE',
            'uri' => '/words/{pos}',
            'summary' => 'Removes the word at position {pos} from the collection.',
            'responseClass' => 'RemoveWordOutput',
            'parameters' => array(
            'word' => array(
                'location' => 'postField',
                    'type' => 'string',
                    'required' => true
                )
            ),
        ),
        'Seed' => array(
            'httpMethod' => 'POST',
            'uri' => '/seed/{num}',
            'summary' => 'Seeds the collection with randomly generated words.',
            'responseClass' => 'SeedOutput',
            'parameters' => array(
                'num' => array(
                    'location'  => 'uri',
                    'sentAs'    => 'n',
                    'type'      => array ( 'integer', 'string' ),
                    'required'  => true
                )
            ),
        )
    ),
    'models' => array(
        'Word' => array(
            'type' => 'object',
            'properties' => array(
                'word' => array(
                    'location' => 'json',
                    'type' => 'string'
                ),
                'metaphone' => array(
                    'location' => 'json',
                    'type' => 'string'
                ),
                'length' => array(
                    'location' => 'json',
                    'type' => 'integer'
                )
            )
        ),
        'WordsMeta' => array(
            'type' => 'object',
            'properties' => array(
                'total' => array(
                    'location' => 'json',
                    'type' => 'integer'
                ),
                'page' => array(
                    'location' => 'json',
                    'type' => 'integer'
                ),
                'pages' => array(
                    'location' => 'json',
                    'type' => 'integer'
                )
            )
        ),
        'AddWordOutput' => array(
            'type' => 'object',
            'properties' => array(
                'location' => array(
                    'location'  => 'header',
                    'sentAs'    => 'Location',
                    'type'      => 'string'
                )
            ),
        ),
        'GetWordOutput' => array(
            'type' => 'object',
            '$ref' => 'Word'
        ),
        'GetWordsOutput' => array(
            'type' => 'object',
            'properties' => array(
                'meta' => array(
                    'location' => 'json',
                    '$ref' => 'WordsMeta'
                ),
                'words' => array(
                    'location' => 'json',
                    'type' => 'array',
                    'items' => array(
                        '$ref' => 'Word'
                    )
                )
            )
        ),
        'RemoveWordOutput' => array(
            'type' => 'object',
            'properties' => array(
                'status' => array(
                    'location'  => 'header',
                    'sentAs'    => 'statusCode',
                    'type'      => 'integer'
                )
            ),
        ),
        'SeedOutput' => array(
            'type' => 'object',
            'properties' => array(
                'words' => array(
                    'location' => 'json',
                    'type' => 'array',
                    'items' => array(
                        '$ref' => 'Word'
                    )
                )
            )
        ),
    )
);
