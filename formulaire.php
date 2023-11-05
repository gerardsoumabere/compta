<?php
    $achat = getAchat();
    $magasin = "";
    $description_achat = "";
    $montant="";
    $acheteur="";
    $mode_paiement="";
    $text_button = "Ajouter l'achat";
    $date_achat = date('Y-m-d');



    if (isset($_GET['id'])){

        $text_button = "Modifier l'achat";
        $date_achat = $achat[0]["date_achat"];
        $magasin = $achat[0]["magasin"];
        $description_achat = $achat[0]["description_achat"];
        $montant=$achat[0]["montant"];
        $acheteur=$achat[0]["acheteur"];
        $mode_paiement=$achat[0]["mode_paiement"];

    }   
?>

<div class="container">
    <form method="post" action="">
            <div class="form-group">
                <label for="date_achat">Date :</label>
                <input type="date" class="form-control" name="date_achat" value="<?php echo $date_achat ?>" required>
            </div>
            <div class="form-group">
                <label for="magasin">Magasin :</label>
                <input type="text" class="form-control" name="magasin" value="<?php echo $magasin ?>"  required>
            </div>
            <div class="form-group">
                <label for="description_achat">Description :</label>
                <textarea class="form-control" name="description_achat"><?php echo $description_achat ?> </textarea>
            </div>
            <div class="form-group">
                <label for="montant">Montant :</label>
                <input type="number" step="0.01" class="form-control" name="montant"  value="<?php echo $montant ?>" required>
            </div>
            <div class="form-group">
                <label for="acheteur">Acheteur :</label>
                <select class="form-control" name="acheteur" " required>
                    <option value="Isabelle">Isabelle</option>
                    <option value="Gérard">Gérard</option>
                    <option value="Guillaume">Guillaume</option>
                    <option value="Information non connue" selected="true">Information non connue</option>
                </select>
            </div>
            <div class="form-group">
                <label for="mode_paiement">Mode de Paiement :</label>
                <select class="form-control" name="mode_paiement" required>
                    <option value="espèce">Espèce</option>
                    <option value="CB">CB</option>
                    <option value="chèque">Chèque</option>
                    <option value="enveloppe">Enveloppe</option>
                    <option value="virement">Virement</option>
                    <option value="Information non connue" selected="true">Information non connue</option>
                </select>
            </div>
            <button type="submit" name="ajouter_achat" class="btn btn-primary"><?php echo $text_button ?></button>
    </form>
</div>
