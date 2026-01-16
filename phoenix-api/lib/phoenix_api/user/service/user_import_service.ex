defmodule PhoenixApi.User.UserImportService do
  alias PhoenixApi.Infrastructure.DataGov.ApiClient
  alias PhoenixApi.Repo
  alias PhoenixApi.User.UserSchema

  @spec import_users() :: {:ok, Integer.t()} | {:error, String.t()}
  def import_users do
    with {:ok, male_first_names} <- ApiClient.fetch_male_first_names,
         {:ok, male_last_names} <- ApiClient.fetch_male_last_names,
         {:ok, female_first_names} <- ApiClient.fetch_female_first_names,
         {:ok, female_last_names} <- ApiClient.fetch_female_last_names do

      popular_male_first_names = male_first_names |> filter_most_popular
      popular_male_last_names = male_last_names |> filter_most_popular
      popular_female_first_names = female_first_names |> filter_most_popular
      popular_female_last_names = female_last_names |> filter_most_popular

      Repo.transaction(fn ->
        import_count = Enum.reduce(1..100, 0, fn _i, acc ->
          %UserSchema{}
          |> UserSchema.changeset(%{
            first_name: popular_male_first_names |> random_name,
            last_name: popular_male_last_names |> random_name,
            birthdate: random_date(),
            gender: :male
          })
          |> Repo.insert!

          acc + 1
        end)

        Enum.reduce(1..100, import_count, fn _i, acc ->
          %UserSchema{}
          |> UserSchema.changeset(%{
            first_name: popular_female_first_names |> random_name,
            last_name: popular_female_last_names |> random_name,
            birthdate: random_date(),
            gender: :female
          })
          |> Repo.insert!

          acc + 1
        end)
      end)
    else
      {:error, _reason} -> {:error, "Import failed"}
    end
  end

  defp filter_most_popular(list),
       do: list
           |> Enum.sort_by(fn name_dto -> name_dto.popularity end, :desc)
           |> Enum.take(100)

  defp random_date do
    days = Date.diff(~D[2024-12-31], ~D[1970-01-01])
    Date.add(~D[1970-01-01], :rand.uniform(days))
  end

  defp random_name(list) do
    random_item = list |> Enum.random
    random_item.name
  end
end