defmodule PhoenixApi.Infrastructure.DataGov.ApiClient do
  alias PhoenixApi.Infrastructure.DataGov.NameDTO
  @type api_call_response :: {:ok, [NameDTO.t()]} | {:error, String.t() | Exception.t()}

  @api_url "https://api.dane.gov.pl/resources/"

  @spec fetch_female_last_names() :: api_call_response()
  def fetch_male_first_names,
      do: "63929,lista-imion-meskich-w-rejestrze-pesel-stan-na-22012025-imie-pierwsze/csv" |> api_call

  @spec fetch_female_last_names() :: api_call_response()
  def fetch_male_last_names,
      do: "63892,nazwiska-meskie-stan-na-2025-01-22/csv" |> api_call

  @spec fetch_female_last_names() :: api_call_response()
  def fetch_female_first_names,
      do: "63924,lista-imion-zenskich-w-rejestrze-pesel-stan-na-22012025-imie-pierwsze/csv" |> api_call

  @spec fetch_female_last_names() :: api_call_response()
  def fetch_female_last_names,
      do: "63888,nazwiska-zenskie-stan-na-2025-01-22/csv" |> api_call

  defp api_call(resource) do
    case Req.get(@api_url <> resource) do
      {:ok, %Req.Response{status: 200, body: body}} -> {:ok, body} |> parse_response
      {:ok, %Req.Response{status: status}} -> {:error, "Invalid response status: #{status}"}
      {:error, exception} -> {:error, exception}
    end
  end

  defp parse_response({:ok, body}) do
    body
    |> String.split("\n", trim: true)
    |> Enum.drop(1)
    |> Enum.map(fn line ->
      case String.split(line, ",") do
        [first, _second, third] ->
          %NameDTO{
            name: first |> String.trim,
            popularity: third |> String.trim |> String.to_integer
          }
        [first, second] ->
          %NameDTO{
            name: first |> String.trim,
            popularity: second |> String.trim |> String.to_integer
          }
        _ -> nil
      end
    end)
    |> Enum.reject(&is_nil/1)
    |> then(&{:ok, &1})
  end
end