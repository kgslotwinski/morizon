defmodule PhoenixApi.Infrastructure.DataGov.NameDTO do
  @type t :: %__MODULE__{
               name: String.t(),
               popularity: Integer.t(),
             }

  defstruct [:name, :popularity]
end