%% Bilge Maras S009842 Industrial Engineering

function frequency = dictWordFrequency(dictionary, readableTarget)
  dictionary = splitSpaces(dictonary);
  readbleTarget = splitSpaces(readableTarget);
  frequency = [];
  
  for i = 1:length(dictionary)
    count = 0;
    w1 = dictionary{i};
    
    for j = 1:length(readableText)
      w2 = readableText{j};
      if length(w1) ~= length(w2)
        continue;
      end
      
      if w1 == w2
        count++;
      end
    end
    
    frequency = [frequency count];
  end
end
