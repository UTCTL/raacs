package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="QuizzesUsersVO")]
	public class QuizzesUsersVO	
	{
		public var id:int;
		public var user_id:int;
		public var quiz_id:int;
		public var publish_start:String;
		public var publish_end:String;
		public var grade:Number;		
	}
}


