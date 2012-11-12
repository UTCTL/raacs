package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="CommentsVO")]
	public class CommentsVO	
	{
		public var id:int;
		public var answer_id:int;
		public var creator_id:int;
		public var media_type:int;
		public var comment:String;
		public var timestamp:String;		
	}
}


