defmodule PhoenixApiWeb.CollectionResponse do
  @derive Jason.Encoder
  @type t(item_type) :: %__MODULE__{
               data: %{
                 results: List.t(item_type),
                 results_count: Integer.t()
               }
             }

  defstruct data: %{results: [], results_count: 0}

  @spec new(List.t(item_type), Integer.t()) :: t(item_type) when item_type: var
  def new(results, results_count) do
    %__MODULE__{
      data: %{
        results: results,
        results_count: results_count
      }
    }
  end
end