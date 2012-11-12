package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="AssignmentsUsersVO")]
	public class AssignmentsUsersVO	
	{
		public var id:int;
		public var user_id:int;
		public var assignment_id:int;
		public var override_publish_start:String;
		public var override_publish_end:String;
		public var grade:Number;		
	}
}


