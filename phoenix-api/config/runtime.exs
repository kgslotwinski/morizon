import Config

# PHX_SERVER=true is required to start the server in production
if System.get_env("PHX_SERVER") do
  config :phoenix_api, PhoenixApiWeb.Endpoint, server: true
end

if config_env() == :prod do
  database_url =
    System.get_env("DATABASE_URL") ||
      raise """
      environment variable DATABASE_URL is missing.
      For example: postgres://USER:PASS@HOST/DATABASE
      """

  config :phoenix_api, PhoenixApi.Repo,
         url: database_url,
         pool_size: String.to_integer(System.get_env("POOL_SIZE") || "10")

  secret_key_base =
    System.get_env("SECRET_KEY_BASE") ||
      raise """
      environment variable SECRET_KEY_BASE is missing.
      You can generate one by calling: mix phx.gen.secret
      """

  host = System.get_env("PHX_HOST") || "example.com"
  port = String.to_integer(System.get_env("PORT") || "4000")

  config :phoenix_api, PhoenixApiWeb.Endpoint,
         url: [host: host, port: 443, scheme: "https"],
         http: [
           ip: {0, 0, 0, 0, 0, 0, 0, 0},
           port: port
         ],
         secret_key_base: secret_key_base
end