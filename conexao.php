<?php

$hostname = "localhost";
$bancodeados = "pessoas";
$usuario = "root";
$senha = "";

// Conecta ao banco de dados
$conn = mysqli_connect($hostname, $usuario, $senha, $bancodeados);

// Verifica se houve erros na conexão com o banco de dados
if ($conn === null) {
    echo "Erro na conexão com o banco de dados: " . mysqli_connect_error();
} else {
    echo "Conexão realizada com sucesso!";
}

// Cria um formulário HTML
echo "<form action='' method='post'>";
echo "<input type='text' name='nome' placeholder='Nome'>";
echo "<input type='text' name='sobrenome' placeholder='Sobrenome'>";
echo "<input type='text' name='genero' placeholder='Gênero'>";
echo "<input type='email' name='email' placeholder='Email'>";
echo "<input type='text' name='telefone' placeholder='Telefone'>";
echo "<input type='submit' value='Enviar'>";
echo "</form>";

// Adiciona um botão de envio ao formulário
if (isset($_POST['nome']) && isset($_POST['sobrenome']) && isset($_POST['genero']) && isset($_POST['email']) && isset($_POST['telefone'])) {
    // Escapa de quaisquer caracteres especiais nos dados do formulário
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $sobrenome = mysqli_real_escape_string($conn, $_POST['sobrenome']);
    $genero = mysqli_real_escape_string($conn, $_POST['genero']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);

    // Altera o nome do registro para garantir que seja único
    $nome = $nome . "_" . rand(1, 100);

    // Verifica se o registro já existe
    $sql = "SELECT * FROM pessoas WHERE nome = '$nome'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        // Insere os dados do formulário no banco de dados
        $sql = "INSERT INTO pessoas (nome, sobrenome, genero, email, telefone) VALUES ('$nome', '$sobrenome', '$genero', '$email', '$telefone')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Consulta todos os registros da tabela
            $sql = "SELECT * FROM pessoas";
            $result = mysqli_query($conn, $sql);

            // Exibe todos os registros da tabela
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div>";
                echo "<p>Nome: " . $row['nome'] . "</p>";
                echo "<p>Sobrenome: " . $row['sobrenome'] . "</p>";
                echo "<p>Gênero: " . $row['genero'] . "</p>";
                echo "<p>E-mail: " . $row['email'] . "</p>";
                echo "<p>Telefone: " . $row['telefone'] . "</p>";
                echo "<button onclick='excluir(" . $row['id'] . ")'>Excluir</button>";
                echo "</div>";
            }

            echo "<hr>";
        } else {
            echo "Erro ao inserir dados: " . mysqli_error($conn);
        }
    } else {
        echo "Registro já existe!";
    }


    // Exibe todos os registros da tabela
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<p>Nome: " . $row['nome'] . "</p>";
        echo "<p>Sobrenome: " . $row['sobrenome'] . "</p>";
        echo "<p>Gênero: " . $row['genero'] . "</p>";
        echo "<p>E-mail: " . $row['email'] . "</p>";
        echo "<p>Telefone: " . $row['telefone'] . "</p>";
        echo "<button onclick='excluir(" . $row['id'] . ")'>Excluir</button>";
        echo "</div>";
    }


}

// Adiciona validação ao formulário
if (isset($_POST['nome']) && isset($_POST['sobrenome']) && isset($_POST['genero']) && isset($_POST['email']) && isset($_POST['telefone'])) {

    // Valida o campo "Nome"
    if (empty($_POST['nome'])) {
        echo "O campo 'Nome' é obrigatório.";
        return;
    }

    // Valida o campo "E-mail"
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "O campo 'E-mail' não é um endereço de e-mail válido.";
        return;
    }

    // ...

}

// Adiciona um botão de reset ao formulário
echo "<form action='cadastro.php' method='post'>";
echo "<button type='reset' class='btn btn-secondary'>Limpar</button>";

// Adiciona um botão de edição ao formulário
if (isset($_POST['nome']) && isset($_POST['sobrenome']) && isset($_POST['genero']) && isset($_POST['email']) && isset($_POST['telefone'])) {

    // ...

} else {

    // Exibe o formulário de cadastro
    echo "<form action='cadastro.php' method='post'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<div class='form-group'>";
    echo "<label for='nome'>Nome</label>";
    echo "<input type='text' class='form-control' id='nome' name='nome' value='$nome'>";
    echo "</div>";

    // ...

    echo "<button type='submit' class='btn btn-primary'>Editar</button>";
    echo "</form>";

}

if (isset($_POST['id'])) {

    // Obtém o ID do registro
    $id = $_POST['id'];

    // Verifica se o ID do registro é válido
    if (is_numeric($id) && $id > 0) {

        // Exclui o registro
        $sql = "DELETE FROM pessoas WHERE id = $id";
        $result = $conn->query($sql);

        if ($result) {
            echo "<div class='alert alert-success' role='alert'>Registro excluído com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao excluir registro: " . mysqli_error($conn) . "</div>";
        }

    } else {

        echo "O ID do registro é inválido.";

    }

}



// Fecha a conexão com o banco
$conn->close();

?>

}

// Fecha a conexão com o banco
