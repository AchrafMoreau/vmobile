<div>
    <div class='filter'>
        <form action="" class='search'>
            <div class="type">
                <select name="type" id="type" class='select'>
                    <option value="">Select Type</option>
                    <option value="type1">Type 1</option>
                    <option value="type2">Type 2</option>
                </select>
            </div>
            <div class="marque" >
                <select name="marque" id="marque" class='select'>
                    <option value="">Select Marque</option>
                    <option value="Apple">Apple</option>
                    <option value="Samsung">Samsung</option>
                </select>
            </div>
            <div class="annee " >
                <select name="annee" id="annee" class='select'>
                    <option value="">Select Annee</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>
            </div>
            <div class="modele">
                <select name="modele" id="modele" class='select'>
                    <option value="">Select Modele</option>
                    <option value="Modele1">Modele 1</option>
                    <option value="Modele2">Modele 2</option>
                </select>
            </div>
            <button type="submit" class="btnSubmit" name="search_mobile">
                Recherche
            </button>
        </form>
    </div>

    <div class='flex'>
        {if isset($mobiles) && $mobiles|@count > 0}
            <ul>
                {foreach from=$mobiles item=mobile}
                    <li>{$mobile.model} - {$mobile.annee} - {$mobile.manufacture}</li>
                {/foreach}
            </ul>
        {else}
            {if Tools::isSubmit('search_mobile')}
                <p>No results found.</p>
            {/if}
        {/if}
    </div>
</div>
