defmodule PhoenixApiWeb.User.UserApiJSON do
  alias PhoenixApiWeb.User.UserDTO

  def index(%{results: users}),
      do: PhoenixApiWeb.CollectionResponse.new(
        for(user <- users, do: UserDTO.new(user)),
        users |> Enum.count
      )

  def show(%{result: user}),
      do: PhoenixApiWeb.ResultResponse.new(UserDTO.new(user))
end