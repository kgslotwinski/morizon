defmodule PhoenixApiWeb.Plugs.ApiTokenPlug do
  import Plug.Conn
  import Phoenix.Controller

  @auth_header "authorization"
  @auth_header_prefix "Bearer "

  def init(opts), do: opts

  def call(conn, _opts) do
    case get_req_header(conn, @auth_header) do
    [@auth_header_prefix <> token] when token != "" ->
        if token == System.get_env("PHOENIX_API_TOKEN") do
            conn
        else
          reject(conn)
        end

      _ ->
        reject(conn)
    end
  end

  defp reject(conn) do
    conn
    |> put_status(:unauthorized)
    |> json(PhoenixApiWeb.ErrorController.render("401", %{}))
    |> halt()
  end
end