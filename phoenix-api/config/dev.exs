import Config

config :phoenix_api, PhoenixApi.Repo,
  username: System.get_env("DATABASE_USER"),
  password: System.get_env("DATABASE_PASSWORD"),
  hostname: System.get_env("DATABASE_HOST"),
  database: System.get_env("DATABASE_NAME"),
  port: String.to_integer(System.get_env("DATABASE_PORT")),
  stacktrace: true,
  show_sensitive_data_on_connection_error: true,
  pool_size: 10

config :phoenix_api, PhoenixApiWeb.Endpoint,
  http: [ip: {0, 0, 0, 0}],
  check_origin: false,
  code_reloader: true,
  debug_errors: true,
  secret_key_base: "BNWpM8QsRer/pCcV8Ne47WV7kMxN5GTOsYDCGGc9HV6ak0j6NFS1xRPS9Kvb31gl",
  watchers: []

config :phoenix_api, dev_routes: true

config :logger, :default_formatter, format: "[$level] $message\n"

config :phoenix, :stacktrace_depth, 20

config :phoenix, :plug_init_mode, :runtime