<table>
 <thead>
 <tr>
 <th> id</th>
 <th> Account no</th>
 <th> Type </th>
 <th> balance </th>
 <th> Interest</th>
Page 8 of 8
 </tr>
 </thead>
 <tbody>
 @foreach($accounts as $account)
 <tr>
 <td> {{$account->id}} </td>
 <td> {{$account->accountno }} </td>
 <td> {{$account->type }} </td>
 <td> {{$account->balance}} </td>
 <td> {{$account->interest}} </td>

 </tr>
 @endforeach
 </tbody>
</table>