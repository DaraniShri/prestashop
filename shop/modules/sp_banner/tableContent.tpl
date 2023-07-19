<div class="panel">
<table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">NAME</th>
        <th scope="col">LINK</th>
        <th scope="col">IMAGE NAME</th>
        <th scope="col">STATUS</th>
        <th scope="col">POSITION</th>
        <th scope="col">ACTION</th>
        </tr>
    </thead>
    <tbody>
        {foreach $sp_table as $rows}
            <tr>
                <td>{$rows['id_slide']}</td>
                <td>{$rows['name_slide']}</td>
                <td>{$rows['link']}</td>
                <td>{$rows['image']}</td>
                <td>{$rows['active']}</td>
                <td>{$rows['position']}</td>  
                <td>
                    <a class="btn btn-default" id="updateData" href="{$link->getAdminLink('AdminModules')}&configure=sp_banner&slide_id={$rows.id_slide}">Update</a>
                    <a class="btn btn-danger" id="deleteData" href="#?id={$rows['id_slide']}">Delete</a>
                </td>  
            </tr>    
        {/foreach}
    </tbody>
</table>
</div>