package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="AnswersVO")]
	public class AnswersVO	
	{
		public var id:int;
		public var user_id:int;
		public var questions_quiz_id:int;
		public var answer_media:String;
		public var answer_type:int;
		public var timestamp:String;
		public var grade:Number;
		public var total_points:Number;		
	}
}


