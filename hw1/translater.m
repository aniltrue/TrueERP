%% Bilge Maras S009842 Industrial Engineering

function readableTarget = translater(target, dictionary)
  target = splitSpaces(target);
  dictionary = splitSpaces(dictionary);
  readableText = '';
  
  for i = 1:length(target)
    word = target{i};
    for j = 1:length(dictionary)
      if checkWordsSame(word, dictionary{j})
        word = dictionary{j};
        break;
      end
    end
    
    readbleText = [readableText ' ' word];
  end
end
