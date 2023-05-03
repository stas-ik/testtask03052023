<?php

function link_to(array $params)
{
    $link_type = isset($params['type']) ? strtolower($params['type']) : 'default';

    $href = isset($params['href']) ? strtolower($params['href']) : 'javascript:void(0);';
    $content = $params['content'] ?? 'link';

    switch ($link_type){
        case 'default':
            $href_prefix = '';
            break;
        case 'tel':
        case 'phone':
            $href_prefix = 'tel:';
            $href = preg_replace("/[^0-9]/", '', $content);
            break;
        case 'email':
            $href_prefix = 'mailto:';
            $href = $content;
            if (!filter_var($href, FILTER_VALIDATE_EMAIL)) {
                $href = 'javascript:void(0)';
                $content = "Invalid email format";
                $href_prefix = '';
            }
            break;
        default:
            $href_prefix = '';

    }
    echo sprintf('<a href="%s%s">%s</a>', $href_prefix, $href, $content);
}

link_to([
    'type' => 'default',
    'content' => 'Link',
    'href' => 'http://example.com',
] );
echo '<br>';
link_to([
    'type' => 'email',
    'content' => 'johndoeexample.com',
]);
echo '<br>';
link_to([
    'type' => 'tel',
    'content' => '+38 123 456 78 90',
]);
echo '<br>';

?>