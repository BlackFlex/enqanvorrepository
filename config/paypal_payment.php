<?php

return [
    # Define your application mode here
    'mode' => 'sandbox',

    # Account credentials from developer portal
    'account' => [
        'client_id' => env('AVgHonfUs3xypnpvwjY6JomDi-0wTvUtrT-0B5-Q4G2OuRJ2q9uCGq2QUyMIhC9oT3afv-maZi8zFVY-', ''),
        'client_secret' => env('EDhAs5FyO11itf8oVRET3nhXskjUMb4mmz4riIPBbkcZPUgSfVtQfX8W5PMUagcCpIRiw6HQgAoUVudU', ''),
    ],

    # Connection Information
    'http' => [
        'connection_time_out' => 30,
        'retry' => 1,
    ],

    # Logging Information
    'log' => [
        'log_enabled' => true,

        # When using a relative path, the log file is created
        # relative to the .php file that is the entry point
        # for this request. You can also provide an absolute
        # path here
        'file_name' => '../PayPal.log',

        # Logging level can be one of FINE, INFO, WARN or ERROR
        # Logging is most verbose in the 'FINE' level and
        # decreases as you proceed towards ERROR
        'log_level' => 'FINE',
    ],
];
