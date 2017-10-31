<?php

class SupportMarkdownTest extends FeatureTestCase
{
    function test_the_post_content_support_markdown()
    {
        $importantText = "Un texto muy importante";

        $post = $this->createPost([
            'body' => "La primera parte del texto. **$importantText**. La última parte del texto"
        ]);

        $this->visit($post->url)
            ->seeInElement('strong', $importantText);
    }

    function test_the_code_in_the_post_is_escaped()
    {
        $xssAttack = "<script>alert('Sharing code')</script>";

        $post = $this->createPost([
            'body' => "`$xssAttack`. Texto normal."
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal')
            ->seeText($xssAttack);
    }

    function test_xss_attack()
    {
        $xssAttack = "<script>alert('Malicious JS!')</script>";

        $post = $this->createPost([
            'body' => "$xssAttack. Texto normal."
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal')
            ->seeText($xssAttack); //todo: fix this!
    }

    function test_xss_attack_with_html()
    {
        $xssAttack = "<img src='img.jpg' />";

        $post = $this->createPost([
            'body' => "$xssAttack. Texto normal."
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack);
    }
}
