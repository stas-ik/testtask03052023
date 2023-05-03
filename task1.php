<?php

function link_to(array $params): string
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
    return sprintf('<a href="%s%s">%s</a>', $href_prefix, $href, $content);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task 1</title>
</head>
<body>

    <?php
        echo link_to([
                'type' => 'default',
                'content' => 'Link',
                'href' => 'http://example.com',
            ] ).'<br>';

        echo link_to([
                'type' => 'email',
                'content' => 'johndoe@example.com',
            ]).'<br>';

        echo link_to([
                'type' => 'tel',
                'content' => '+38 123 456 78 90',
            ]).'<br>';
    ?>
</body>
</html>