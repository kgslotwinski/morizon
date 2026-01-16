import Config

config :phoenix_api,
       ecto_repos: [PhoenixApi.Repo],
       generators: [timestamp_type: :utc_datetime]

config :phoenix_api, PhoenixApiWeb.Endpoint,
       url: [host: "localhost"],
       adapter: Bandit.PhoenixAdapter,
       render_errors: [
         formats: [json: PhoenixApiWeb.ErrorController],
         layout: false
       ],
       pubsub_server: PhoenixApi.PubSub,
       live_view: [signing_salt: "EFeaMY04"]

config :logger, :default_formatter,
       format: "$time $metadata[$level] $message\n",
       metadata: [:request_id]

config :phoenix, :json_library, Jason

import_config "#{config_env()}.exs"