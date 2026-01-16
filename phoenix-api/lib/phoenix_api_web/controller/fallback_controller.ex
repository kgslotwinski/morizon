defmodule PhoenixApiWeb.FallbackController do
  use PhoenixApiWeb, :controller

  def call(conn, {:error, %Ecto.Changeset{} = changeset}) do
    conn
    |> put_status(:unprocessable_entity)
    |> json(PhoenixApiWeb.ErrorResponse.new(changeset.errors))
  end

  def call(conn, {:error, :not_found}) do
    conn
    |> put_status(:not_found)
    |> json(PhoenixApiWeb.ErrorResponse.new(%{detail: "Not found"}))
  end
end
