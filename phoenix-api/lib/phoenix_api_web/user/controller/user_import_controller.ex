defmodule PhoenixApiWeb.User.UserImportController do
  use PhoenixApiWeb, :controller

  def import(conn, _params) do
    case PhoenixApi.User.import_users do
      {:ok, import_count} ->
        conn
        |> json(%{message: "Imported #{import_count} users}"})
      {:error, reason} ->
        conn
        |> put_status(:internal_server_error)
        |> json(PhoenixApiWeb.ErrorResponse.new(%{detail: reason}))
    end
  end
end
