<?php

namespace Zerotoprod\SpapiTokens\Contracts;

/**
 * Get a Restricted Data Token (RDT) for Amazon Selling Partner API (SPAPI).
 *
 * The Selling Partner API for Tokens provides a secure way to access a customer's PII
 * (Personally Identifiable Information). You can call the Tokens API to get a
 * Restricted Data Token (RDT) for one or more restricted resources that you
 * specify. The RDT authorizes subsequent calls to restricted operations
 * that correspond to the restricted resources that you specified.
 *
 * @see  https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
 * @link https://github.com/zero-to-prod/spapi-tokens
 */
interface SpapiTokensInterface
{
    /**
     * @param  string  $path                    The path in the restricted resource. Here are some path examples:
     *                                          - /orders/v0/orders. For getting an RDT for the getOrders operation of the Orders API. For bulk orders.
     *                                          - /orders/v0/orders/123-1234567-1234567. For getting an RDT for the getOrder operation of the Orders API. For a specific order.
     *                                          - /orders/v0/orders/123-1234567-1234567/orderItems. For getting an RDT for the getOrderItems operation of the Orders API. For the order items in a specific order.
     *                                          - /mfn/v0/shipments/FBA1234ABC5D. For getting an RDT for the getShipment operation of the Shipping API. For a specific shipment.
     *                                          - /mfn/v0/shipments/{shipmentId}. For getting an RDT for the getShipment operation of the Shipping API. For any of a selling partner's shipments that you specify when you call the getShipment operation.
     * @param  array   $dataElements            Indicates the type of Personally Identifiable Information requested. This parameter is required only when getting an RDT for use with the getOrder, getOrders, or getOrderItems operation of the Orders API. For more information, see the Tokens API Use Case Guide. Possible values include:
     *                                          - buyerInfo. On the order level this includes general identifying information about the buyer and tax-related information. On the order item level this includes gift wrap information and custom order information, if available.
     *                                          - shippingAddress. This includes information for fulfilling orders.
     *                                          - buyerTaxInformation. This includes information for issuing tax invoices
     * @param  array   $options                 Curl options.
     *
     * @return array{
     *  info: array{
     *      url: string,
     *      content_type: string,
     *      http_code: int,
     *      header_size: int,
     *      request_size: int,
     *      filetime: int,
     *      ssl_verify_result: int,
     *      redirect_count: int,
     *      total_time: float,
     *      namelookup_time: float,
     *      connect_time: float,
     *      pretransfer_time: float,
     *      size_upload: int,
     *      size_download: int,
     *      speed_download: int,
     *      speed_upload: int,
     *      download_content_length: int,
     *      upload_content_length: int,
     *      starttransfer_time: float,
     *      redirect_time: float,
     *      redirect_url: string,
     *      primary_ip: string,
     *      certinfo: array,
     *      primary_port: int,
     *      local_ip: string,
     *      local_port: int,
     *      http_version: int,
     *      protocol: int,
     *      ssl_verifyresult: int,
     *      scheme: string,
     *      appconnect_time_us: int,
     *      connect_time_us: int,
     *      namelookup_time_us: int,
     *      pretransfer_time_us: int,
     *      redirect_time_us: int,
     *      starttransfer_time_us: int,
     *      total_time_us: int
     *  },
     *  error: string,
     *  headers: array{
     *      Server: string,
     *      Date: string,
     *      Content-Type: string,
     *      Content-Length: string,
     *      Connection: string,
     *      'x-amz-rid': string,
     *      'x-amzn-RateLimit-Limit': string,
     *      'x-amzn-RequestId': string,
     *      'x-amz-apigw-id': string,
     *      'X-Amzn-Trace-Id': string,
     *      Vary: string,
     *      'Strict-Transport-Security': string
     *  },
     *  response: array{
     *      expiresIn: int,
     *      restrictedDataToken: string
     *  }
     *
     * @see  https://developer-docs.amazon.com/sp-api/docs/tokens-api-v2021-03-01-reference
     * @link https://github.com/zero-to-prod/spapi-tokens
     */
    public function createRestrictedDataToken(string $path, array $dataElements = [], array $options = []): array;
}