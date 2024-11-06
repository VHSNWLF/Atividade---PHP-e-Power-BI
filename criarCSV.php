<?php

/* Geração de arquivo CSV */

include("conexaoBD.php");

try {
    $stmt = $pdo->prepare("select * from livro order by codigo, autor");
    $stmt->execute();

    $fp = fopen('arquivoLivros.csv', 'w');
    
    $colunasTitulo = array("codigo", "autor", "nome", "paginas", "gênero");

    fputcsv($fp, $colunasTitulo);

    while ($row = $stmt->fetch()) {
        $codigo = $row["codigo"];
        $autor = $row["autor"];
        $nome = $row["nome"];
        $paginas = $row["paginas"];
        $genero = $row["gênero"];

        $lista = array (
            array($codigo, $autor, $nome, $paginas, $genero)
        );
        
        foreach ($lista as $linha) {
            fputcsv($fp, $linha);
        }        
    }

    $msg = "Arquivo gerado: arquivoAlunos.csv";
    fclose($fp);

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Livros em CSV</title>
</head>

<body>
    <h1>Listagem de Alunos em CSV</h1>
    <?= $msg ?>
</body>
</html>