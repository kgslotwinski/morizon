defmodule PhoenixApiWeb.Router do
  use PhoenixApiWeb, :router

  pipeline :api do
    plug :accepts, ["json"]
    plug PhoenixApiWeb.Plugs.ApiTokenPlug
  end

  scope "/", PhoenixApiWeb do
    pipe_through :api

    resources "/users", User.UserApiController, except: [:new, :edit]
    post "/import", User.UserImportController, :import
  end
end
