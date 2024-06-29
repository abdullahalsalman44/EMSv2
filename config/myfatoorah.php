<?php

return [
    /**
     * API Token Key (string)
     * Accepted value:
     * Live Token: https://myfatoorah.readme.io/docs/live-token
     * Test Token: https://myfatoorah.readme.io/docs/test-token
     */
    'api_key' => 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL',
//    'api_key'=>'8eeoDH77KXxZa1PBgqySpbz0ZALBRtf7etrbxduVYJxrMpXFGm9gXoGWUAFZLZObqt2fHedg4Bd2KPNDpoGhG2weFAwUDr3ugK3kZVKvjxQlAjLqgOtHZQZDXLBjn1zF6xC5Zv_2YB-aAX1LJkp_YEIB0W1FcLtLBlKuCae-6ebf3708Pxw4yzBZ7xpt2GnsECrNFDpUA4j3EAhbjk2s9i2oSYvjlMYrPjDOupd8SAafV6NRsyfmSSL95C1AyrwxKzga-nFYVGSGnfpqU8rzWsC47CNQ3ClHCPxJTfNfn15krB-jBj3k9E5QtEuhj4Fsi0-lzyYMsdQby0OHdJtegg3yq2E139ZotQoJtaNAch1M0xSZaXX7slq85p-MXa2N5lUTZFqdomisDYW1F9wS6ZfpTtUCnuMMkRdbfEAfh2GVg4F6UbmFma-A2WUgY_toPg229ON65poqB51oYCNSGH_W7PvqVtnUnYmnKBp1qxoVMB-rI41k1llLOsq2j9Lt-mSpEAELfH7kP8SlR8Rmw-hnsh9ne2Xyf382gaKHUWwoBJlM1CV3CmDHdop-Jyvzzr3MgqAtAKBy6odObm00ULuiffbfx8y2aYy55CVPA8OMx6lHzpIRoogJ150xS9wLyAo2iLh0SsThoa50l-XKaT47cAPnbnVfGyxulCeGLLhXD4Qhbr2HmN_ehuMdSZ1TmlLZqg',
    /**
     * Test Mode (boolean)
     * Accepted value: true for the test mode or false for the live mode
     */
    'test_mode' => true,
    /**
     * Country ISO Code (string)
     * Accepted value: KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY.
     */
    'country_iso' => 'KWT',
    /**
     * Save card (boolean)
     * Accepted value: true if you want to enable save card options.
     * You should contact your account manager to enable this feature in your MyFatoorah account as well.
     */
    'save_card' => true,
    /**
     * Webhook secret key (string)
     * Enable webhook on your MyFatoorah account setting then paste the secret key here.
     * The webhook link is: https://{example.com}/myfatoorah/webhook
     */
    'webhook_secret_key' => '',
    /**
     * Register Apple Pay (boolean)
     * Set it to true to show the Apple Pay on the checkout page.
     * First, verify your domain with Apple Pay before you set it to true.
     * You can either follow the steps here: https://docs.myfatoorah.com/docs/apple-pay#verify-your-domain-with-apple-pay or contact the MyFatoorah support team (tech@myfatoorah.com).
    */
    'register_apple_pay' => false
];
