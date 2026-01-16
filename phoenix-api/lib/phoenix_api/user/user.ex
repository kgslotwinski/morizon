defmodule PhoenixApi.User do
  alias PhoenixApi.User.UserImportService
  alias PhoenixApi.User.UserSchema
  alias PhoenixApi.User.UserQuery
  alias PhoenixApi.Repo

  @spec import_users() :: {:ok, Integer.t()} | {:error, String.t()}
  def import_users, do: UserImportService.import_users

  @spec fetch_users(Map.t()) :: {:ok, [UserSchema.t()]} | {:error, Ecto.Changeset.t()}
  def fetch_users(data \\ %{}) do
    with {:ok, filters} <- data |> UserQuery.validate_filters do
      filters
      |> UserQuery.build_query
      |> Repo.all
    end
  end

  @spec fetch_user!(Integer.t()) :: UserSchema.t()
  def fetch_user!(id), do: Repo.get!(UserSchema, id)

  @spec create_user(Map.t()) :: {:ok, UserSchema.t()} | {:error, Ecto.Changeset.t()}
  def create_user(data \\ %{}),
      do: %UserSchema{}
          |> UserSchema.changeset(data)
          |> Repo.insert

  @spec update_user(Integer.t(), Map.t()) :: {:ok, UserSchema.t()} | {:error, Ecto.Changeset.t()}
  def update_user(id, data),
      do: id
          |> fetch_user!
          |> UserSchema.changeset(data)
          |> Repo.update

  @spec delete_user(Integer.t()) :: {:ok, UserSchema.t()} | {:error, Ecto.Changeset.t()}
  def delete_user(id),
      do: id
          |> fetch_user!
          |> Repo.delete
end