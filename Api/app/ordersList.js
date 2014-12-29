/** @jsx React.DOM */
var Table = ReactBootstrap.Table;
var tableInstace = (
    <Table nav navbar-nav navbar-right>
      <thead>
        <tr>
          <th>生产单号</th>
          <th>品名</th>
          <th>生产状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Jacob</td>
          <td>Thornton</td>
          <td>@fat</td>
        </tr>
        <tr>
          <td>3</td>
          <td colSpan="2">Larry the Bird</td>
          <td>@twitter</td>
        </tr>
      </tbody>
    </Table>
  );

var OrdersList = React.createClass({
	render: function(){
		return tableInstace;
	}
})

