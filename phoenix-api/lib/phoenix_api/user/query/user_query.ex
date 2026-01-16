defmodule PhoenixApi.User.UserQuery do
  use Ecto.Schema
  import Ecto.Query
  alias PhoenixApi.User.UserSchema
  alias PhoenixApi.User.UserFilterSchema

  @spec build_query(UserFilterSchema.t()) :: Ecto.Query.t()
  def build_query(filters \\ %UserFilterSchema{}) do
    UserSchema
    |> filter_by_first_name(filters.first_name)
    |> filter_by_last_name(filters.last_name)
    |> filter_by_gender(filters.gender)
    |> filter_by_birthdate_from(filters.birthdate_from)
    |> filter_by_birthdate_to(filters.birthdate_to)
    |> sort(filters.sort, filters.sort_direction)
  end

  @spec validate_filters(Map.t()) :: {:ok, UserFilterSchema.t()} | {:error, Ecto.Changeset.t()}
  def validate_filters(params \\ %{}) do
    changeset = %UserFilterSchema{} |> UserFilterSchema.changeset(params)

    if changeset.valid? do
      {:ok, Ecto.Changeset.apply_changes(changeset)}
    else
      {:error, changeset}
    end
  end

  defp filter_by_first_name(query, nil), do: query
  defp filter_by_first_name(query, first_name), do: where(query, [u], ilike(u.first_name, ^"%#{first_name}%"))

  defp filter_by_last_name(query, nil), do: query
  defp filter_by_last_name(query, last_name), do: where(query, [u], ilike(u.last_name, ^"%#{last_name}%"))

  defp filter_by_gender(query, nil), do: query
  defp filter_by_gender(query, gender), do: where(query, gender: ^gender)

  defp filter_by_birthdate_from(query, nil), do: query
  defp filter_by_birthdate_from(query, from),
       do: query |> then(fn q -> if from, do: where(q, [u], u.birthdate >= ^from), else: q end)

  defp filter_by_birthdate_to(query, nil), do: query
  defp filter_by_birthdate_to(query, to),
       do: query |> then(fn q -> if to, do: where(q, [u], u.birthdate <= ^to), else: q end)

  defp sort(query, nil, _), do: order_by(query, [u], desc: u.id)
  defp sort(query, field, direction), do: query |> order_by([u], [{^direction, field(u, ^field)}])
end