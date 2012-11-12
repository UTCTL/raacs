package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="AssignmentsVO")]
	public class AssignmentsVO	
	{
		public var id:int;
		public var group_id:int;
		public var quiz_id:int;
		public var publish_start:String;
		public var publish_end:String;
		public var name:String;		
	}
}


