<?php

declare(strict_types=1);

namespace Tests\Sylius\ElasticSearchPlugin\Controller;

use Lakion\ApiTestCase\JsonApiTestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

final class SearchControllerApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB'], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_DE_channel_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_DE'], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_DE/de_DE/product_list_page', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_using_de_DE_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'locale' => 'de_DE'], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/de_DE/product_list_page', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_taxon_code_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/taxon-products/MUG', ['channel' => 'WEB_GB'], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertProductsCodesInResponse($this->client->getResponse(), ['LOGAN_MUG_CODE']);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_taxon_code_sorted_by_position_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/taxon-products/BRAND', ['channel' => 'WEB_GB'], [], ['ACCEPT' => 'application/json']);

        $this->assertProductsCodesInResponse(
            $this->client->getResponse(),
            ['LOGAN_HAT_CODE', 'LOGAN_T_SHIRT_CODE', 'LOGAN_MUG_CODE']
        );
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_taxon_slug_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/taxon-products-by-slug/categories/mugs', ['channel' => 'WEB_GB'], [], ['ACCEPT' => 'application/json']);

        $this->assertProductsCodesInResponse($this->client->getResponse(), ['LOGAN_MUG_CODE']);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_taxon_slug_sorted_by_position_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/taxon-products-by-slug/brands', ['channel' => 'WEB_GB'], [], ['ACCEPT' => 'application/json']);

        $this->assertProductsCodesInResponse(
            $this->client->getResponse(),
            ['LOGAN_HAT_CODE', 'LOGAN_T_SHIRT_CODE', 'LOGAN_MUG_CODE']
        );
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_an_attribute_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'attributes' => ['Mug material' => ['Wood']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_mug_material_wood_attribute', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_an_attribute_with_multiple_values_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'attributes' => ['Production year' => ['2015', '2020']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_production_year_2015_or_2020_attribute', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_two_attributes_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'attributes' => ['Production year' => ['2015', '2020'], 'Mug material' => ['Wood']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_production_year_2015_or_2020_and_mug_material_wood_attribute', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_an_attribute_using_de_DE_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'locale' => 'de_DE', 'attributes' => ['Becher Material' => ['Holz']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/de_DE/product_list_page_filtered_by_mug_material_wood_attribute', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_an_attribute_referenced_by_code_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'attributesByCode' => ['PRODUCTION_YEAR' => ['2015']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_production_year_2015_attribute', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_an_attribute_with_multiple_values_referenced_by_code_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'attributesByCode' => ['PRODUCTION_YEAR' => ['2015', '2020']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_production_year_2015_or_2020_attribute', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_two_attributes_referenced_by_code_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'attributesByCode' => ['PRODUCTION_YEAR' => ['2015', '2020'], 'MUG_MATERIAL_CODE' => ['Wood']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_production_year_2015_or_2020_and_mug_material_wood_attribute', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_an_attribute_referenced_by_code_using_de_DE_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'locale' => 'de_DE', 'attributesByCode' => ['PRODUCTION_YEAR' => ['2015']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/de_DE/product_list_page_filtered_by_production_year_2015_attribute', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_price_range_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'price' => '1000;1500'], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_price_range', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_phrase_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'search' => 'hat'], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_phrase', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_partial_phrase_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'search' => 'holiDAY'], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_filtered_by_partial_phrase', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_filtered_by_phrase_using_de_DE_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'locale' => 'de_DE', 'search' => 'hut'], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/de_DE/product_list_page_filtered_by_phrase', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_first_product_list_page_limited_to_two_from_WEB_GB_channel_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'limit' => 2, 'page' => 1], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/first_product_list_page_limited_to_two', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_second_product_list_page_limited_to_two_from_WEB_GB_channel_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'limit' => 2, 'page' => 2], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/second_product_list_page_limited_to_two', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_sorted_by_price_ascending_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'sort' => ['price' => 'asc']], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_sorted_by_price_ascending', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_sorted_by_price_descending_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'sort' => ['price' => 'desc']], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_sorted_by_price_descending', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_sorted_by_name_ascending_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'sort' => ['name' => 'asc']], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_sorted_by_name_ascending', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_sorted_by_name_descending_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'sort' => ['name' => 'desc']], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_sorted_by_name_descending', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_sorted_by_production_year_attribute_ascending_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'sort' => ['attributes' => ['PRODUCTION_YEAR' => 'asc']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_sorted_by_production_year_attribute_ascending', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_shows_product_list_page_from_WEB_GB_channel_sorted_by_production_year_attribute_descending_using_default_locale()
    {
        $this->loadFixturesFromFile('shop.yml');

        $this->client->request('GET', '/shop-api/products', ['channel' => 'WEB_GB', 'sort' => ['attributes' => ['PRODUCTION_YEAR' => 'desc']]], [], ['ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'WEB_GB/en_GB/product_list_page_sorted_by_production_year_attribute_descending', Response::HTTP_OK);
    }

    /**
     * @before
     */
    protected function purgeElasticSearch()
    {
        $elasticSearchManager = static::$sharedKernel->getContainer()->get('es.manager.default');
        $elasticSearchManager->dropAndCreateIndex();
    }

    private function assertProductsCodesInResponse(Response $response, array $expectedProductsCodes): void
    {
        $responseContent = json_decode($response->getContent(), true);

        Assert::assertArrayHasKey('items', $responseContent);

        Assert::assertSame(
            $expectedProductsCodes,
            array_map(function (array $item): string {
                return $item['code'];
            }, $responseContent['items'])
        );
    }
}
