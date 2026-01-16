defmodule PhoenixApiWeb.ErrorResponse do
  @derive Jason.Encoder
  @type t :: %__MODULE__{errors: Any.t()}

  defstruct [:errors]

  @spec new(Any.t()) :: t()
  def new(errors), do: %__MODULE__{errors: errors}
end