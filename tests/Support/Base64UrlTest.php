<?php

namespace HansCrypt\Tests\Support;

use HansCrypt\Support\Base64Url;
use PHPUnit\Framework\TestCase;

class Base64UrlTest extends TestCase
{
    public function test_it_round_trips_binary_data(): void
    {
        $data = random_bytes(32);

        $this->assertSame($data, Base64Url::decode(Base64Url::encode($data)));
    }

    public function test_encoded_output_is_url_safe(): void
    {
        $data = random_bytes(64);

        $encoded = Base64Url::encode($data);

        $this->assertMatchesRegularExpression('/^[A-Za-z0-9_-]*$/', $encoded);
    }
}
