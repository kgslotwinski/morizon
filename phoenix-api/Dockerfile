FROM elixir:1.19.4

WORKDIR /var/app

RUN mix local.hex --force

COPY mix.exs mix.lock ./

RUN mix deps.get

COPY . .