package edu.utexas.raacs.model.vo
{
	[Bindable]
	[RemoteClass(alias="QuestionPartsVO")]
	public class QuestionPartsVO	
	{
		public var id:int;
		public var question_id:int;
		public var part_order:int;
		public var media:String;
		public var media_type:int;
		public var in_point:Number;
		public var out_point:Number;
		public var duration:Number;
		public var stop_at_end:int;		
	}
}


