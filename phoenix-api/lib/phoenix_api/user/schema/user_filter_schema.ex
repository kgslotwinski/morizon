defmodule PhoenixApi.User.UserFilterSchema do
  use Ecto.Schema
  import Ecto.Changeset

  @primary_key false
  embedded_schema do
    field :first_name, :string
    field :last_name, :string
    field :gender, Ecto.Enum, values: [:male, :female]
    field :birthdate_from, :date
    field :birthdate_to, :date
    field :sort, Ecto.Enum, values: [:first_name, :last_name, :birthdate, :gender, :id]
    field :sort_direction, Ecto.Enum, values: [:asc, :desc]
  end

  @spec changeset(UserFilterSchema.t() | Ecto.Changeset.t(), Map.t()) :: Ecto.Changeset.t()
  def changeset(filter, attrs) do
    filter
    |> cast(attrs, [:first_name, :last_name, :gender, :birthdate_from, :birthdate_to, :sort, :sort_direction])
  end
end