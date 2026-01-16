defmodule PhoenixApiWeb.ResultResponse do
  @derive Jason.Encoder
  @type t(item_type) :: %__MODULE__{
    data: %{
      result: item_type
    }
  }

  defstruct data: %{result: nil}

  @spec new(item_type) :: t(item_type) when item_type: var
  def new(result) do
    %__MODULE__{
      data: %{
        result: result
      }
    }
  end
end