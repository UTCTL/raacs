package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="UsersVO")]
	public class UsersVO	
	{
		public var id:int;
		public var last_name:String;
		public var first_name:String;
		public var eid:String;
		public var uin:String;
		public var role:String;
		public var password:String;		
	}
}


