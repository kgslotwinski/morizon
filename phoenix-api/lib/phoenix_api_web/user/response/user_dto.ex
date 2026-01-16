defmodule PhoenixApiWeb.User.UserDTO do
  alias PhoenixApi.User.UserSchema

  @derive Jason.Encoder
  @type t :: %__MODULE__{
          id: Integer.t(),
          first_name: String.t(),
          last_name: String.t(),
          gender: String.t(),
          birthdate: Date.t()
        }

  defstruct [:id, :first_name, :last_name, :gender, :birthdate]

  @spec new(UserSchema.t()) :: t()
  def new(user) do
    %__MODULE__{
      id: user.id,
      first_name: user.first_name,
      last_name: user.last_name,
      gender: user.gender,
      birthdate: user.birthdate
    }
  end
end