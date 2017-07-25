a =input("Please enter a number : ");
satir =1;

i =2;
while i <=a
  s =0;
  
  for j =2:i-1
  if mod(i,j) ==0
    s =-1;
  end
  end
  
  if s ==0
    k =1;
    while k <=satir;
    if (k==1)
    fprintf("%d",i);
    else
    fprintf("%d,", i);
    end
    k+=1;
    end
    
    satir+=1;
    fprintf("\n");
  end
  
  i+=1;
end
