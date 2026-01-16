defmodule PhoenixApiWeb.User.UserApiController do
  use PhoenixApiWeb, :controller
  alias PhoenixApi.User
  action_fallback PhoenixApiWeb.FallbackController

  def index(conn, data) do
    conn
    |> render(:index, results: User.fetch_users(data))
  end

  def create(conn, params) do
    with {:ok, user} <- User.create_user(params) do
      conn
      |> put_status(:created)
      |> render(:show, result: user)
    end
  end

  def show(conn, %{"id" => id}) do
    conn
    |> render(:show, result: User.fetch_user!(id))
  rescue
    Ecto.NoResultsError -> conn |> not_found
  end

  def update(conn, %{"id" => id} = params) do
    data = Map.delete(params, "id")

    with {:ok, user} <- User.update_user(id, data) do
      conn
      |> render(:show, result: user)
    end
  rescue
    Ecto.NoResultsError -> conn |> not_found
  end

  def delete(conn, %{"id" => id}) do
    with {:ok, _user} <- User.delete_user(id) do
      send_resp(conn, :no_content, "")
    end
  rescue
    Ecto.NoResultsError -> conn |> not_found
  end

  defp not_found(conn) do
    conn
    |> put_status(:not_found)
    |> json(PhoenixApiWeb.ErrorResponse.new(%{detail: "User not found"}))
  end
end