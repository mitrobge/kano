{* admin_files.tpl *}
{load_presentation_object filename="admin_files" assign="obj"}
 <div id="box">
  
  
  <form id="form" enctype="multipart/form-data" method="post" action="{$obj->mLinkToFilesAdmin}">
  
  <fieldset id="image">
  
  <legend>Διαχείριση αρχείων</legend>

  <label>Αρχείο:</label>
    
    <input name="image_file" type="file" value="Μεταφόρτωση" />
    <input id="button1" type="submit" name="submit_upload_file" value="Μεταφόρτωση" />
  
  <br />
  
    </form>
    
    <form id="form" method="post" action="">
        <legend>Αρχεία</legend>

        <table>
          <thead>
           <th>ID</th>
           <th>Αρχείο</th>
           <th>Μέγεθος</th>
           <th>Διαστάσεις</th>
           <th>Link</th>
           <th>Τύπος αρχείου</th>
           <th>Ενέργεια</th>
          </thead>
          {section name=i loop=$obj->mFiles}
          <tr>
            <td class="a-center">{$obj->mFiles[i].file_id}</td>
            <td class="a-center">{$obj->mFiles[i].filename}</td>
            <td class="a-center">{$obj->mFiles[i].filesize}</td>
            <td class="a-center">{$obj->mFiles[i].imagesize.3}</td>
            <td class="a-center">content/{$obj->mFiles[i].filename}</td>
            <td class="a-center">{$obj->mFiles[i].filetype}</td>
              <nobr>
              <td class="a-center">
              <input style="width: 100px;" id="button1" type="submit" name="submit_delete_file_{$obj->mFiles[i].file_id}"
                value="Διαγραφή" /></nobr>
            </td>
          </tr>
          {/section}
        </table>
        <br><br>
    </form>
</div>
