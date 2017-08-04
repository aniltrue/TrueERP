fucntion result = checkWordsSame(w1, w2)
  w1 = lower(w1);
  w2 = lower(w2);
  
  if length(w1) ~= length(w2)
    result = false;
    
  else
    result = true;
    w3 = 1:length(w2);
    
    for i = 1:length(w1)
      check = false;
      
      for j = 1:length(w2)
        if w1(i) == w2(j) && w3(j) ~= 0
          check = true;
          w3(j) = 0;
          break;
        end
      end
      
      if ~check
        result = false;
        break;
      end
      
    end
  end
end
